/*
 * Copyright (c) 1997-2007 Erez Zadok <ezk@cs.stonybrook.edu>
 * Copyright (c) 2001-2007 Stony Brook University
 *
 * For specific licensing information, see the COPYING file distributed with
 * this package, or get one from
 * ftp://ftp.filesystems.org/pub/fistgen/COPYING.
 *
 * This Copyright notice must be kept intact and distributed with all
 * fistgen sources INCLUDING sources generated by fistgen.
 */
/*
 * File: fistgen/templates/Linux-2.6/mmap.c
 */

#ifdef HAVE_CONFIG_H
# include <config.h>
#endif /* HAVE_CONFIG_H */
#ifdef FISTGEN
# include "fist_monitorfs.h"
#endif /* FISTGEN */
#include "fist.h"
#include "monitorfs.h"


#ifdef FIST_COUNT_WRITES
/* for counting writes in the middle vs. regular writes */
unsigned long count_writes = 0, count_writes_middle = 0;
#endif /* FIST_COUNT_WRITES */

/* forward declaration of commit write and prepare write */
STATIC int monitorfs_commit_write(file_t *file, page_t *page, unsigned from, unsigned to);
STATIC int monitorfs_prepare_write(file_t *file, page_t *page, unsigned from, unsigned to);

STATIC int
monitorfs_writepage(page_t *page, struct writeback_control *wbc)
{
	int err = -EIO;
	inode_t *inode;
	inode_t *lower_inode;
	page_t *lower_page;
	char *kaddr, *lower_kaddr;

	print_entry_location();

	inode = page->mapping->host;
	lower_inode = INODE_TO_LOWER(inode);


	if (lower_inode->i_mapping->a_ops->writepage)
		err = lower_inode->i_mapping->a_ops->writepage(page, wbc);

	print_exit_status(err);
	return err;
}

/*
 * readpage is called from generic_page_read and the fault handler.
 * If your file system uses generic_page_read for the read op, it
 * must implement readpage.
 *
 * Readpage expects a locked page, and must unlock it.
 */
STATIC int
monitorfs_readpage(file_t *file, page_t *page)
{
	int err = -EIO;
	struct dentry *dentry;
	file_t *lower_file = NULL;
	struct dentry *lower_dentry;
	inode_t *inode;
	inode_t *lower_inode;

	print_entry_location();

	dentry = file->f_dentry; /* CPW: Moved below print_entry_location */
	if (FILE_TO_PRIVATE(file) == NULL) {
		err = -ENOENT;
		goto out_err;
	}
	lower_file = FILE_TO_LOWER(file);
	BUG_ON(!lower_file);	/* XXX: is this assertion right here? */
	lower_dentry = DENTRY_TO_LOWER(dentry);
	inode = dentry->d_inode;
	lower_inode = INODE_TO_LOWER(inode);

	fist_dprint(7, "%s: requesting page %lu from file %s\n", __FUNCTION__, page->index, dentry->d_name.name);

	if (lower_inode->i_mapping->a_ops->readpage)
		err = lower_inode->i_mapping->a_ops->readpage(lower_file, page);
	
out_err:
	print_exit_status(err);
	return err;
}


STATIC int
monitorfs_prepare_write(file_t *file, page_t *page, unsigned from, unsigned to)
{
	int err = 0;
        struct dentry *dentry;
        file_t *lower_file = NULL;
        struct dentry *lower_dentry;
        inode_t *inode;
        inode_t *lower_inode;

        print_entry_location();

        dentry = file->f_dentry; /* CPW: Moved below print_entry_location */
        if (FILE_TO_PRIVATE(file) == NULL) {
                err = -ENOENT;
                goto out_err;
        }
        lower_file = FILE_TO_LOWER(file);
        BUG_ON(!lower_file);    /* XXX: is this assertion right here? */
        lower_dentry = DENTRY_TO_LOWER(dentry);
        inode = dentry->d_inode;
        lower_inode = INODE_TO_LOWER(inode);

	print_entry_location();

        if (lower_inode->i_mapping->a_ops->prepare_write)
                err = lower_inode->i_mapping->a_ops->prepare_write(lower_file, page, from, to);

out_err:
	print_exit_status(err);
	return err;
}




STATIC int
monitorfs_commit_write(file_t *file, page_t *page, unsigned from, unsigned to)
{
        int err = 0;
        struct dentry *dentry;
        file_t *lower_file = NULL;
        struct dentry *lower_dentry;
        inode_t *inode;
        inode_t *lower_inode;

        print_entry_location();

        dentry = file->f_dentry; /* CPW: Moved below print_entry_location */
        if (FILE_TO_PRIVATE(file) == NULL) {
                err = -ENOENT;
                goto out_err;
        }
        lower_file = FILE_TO_LOWER(file);
        BUG_ON(!lower_file);    /* XXX: is this assertion right here? */
        lower_dentry = DENTRY_TO_LOWER(dentry);
        inode = dentry->d_inode;
        lower_inode = INODE_TO_LOWER(inode);

        print_entry_location();

        if (lower_inode->i_mapping->a_ops->commit_write)
                err = lower_inode->i_mapping->a_ops->commit_write(lower_file, page, from, to);

		dentry = file->f_dentry;
		monitorfs_log_operation(MONITORFS_OPS_MODIFY, dentry, NULL, file);
out_err:
        print_exit_status(err);
        return err;
}



STATIC sector_t
monitorfs_bmap(struct address_space *mapping, sector_t block)
{
        int err = 0;
        inode_t *inode;
        inode_t *lower_inode;

        print_entry_location();

        inode = (inode_t *) mapping->host;
        lower_inode = INODE_TO_LOWER(inode);

        if (lower_inode->i_mapping->a_ops->bmap)
                err = lower_inode->i_mapping->a_ops->bmap(lower_inode->i_mapping, block);
        print_exit_location();
        return err;
}

/*
 * XXX: we may not need this function if not FIST_FILTER_DATA.
 * FIXME: for FIST_FILTER_SCA, get all lower pages and sync them each.
 * XXX: address_space_operations.sync_page returns void in .17 and up.
 *      how do you handle the -ENOMEM error?
 */
#if LINUX_VERSION_CODE < KERNEL_VERSION(2,6,17)
STATIC int
#else
STATIC void
#endif /* LINUX_VERSION_CODE < KERNEL_VERSION(2,6,17) */
monitorfs_sync_page(page_t *page)
{
        int err = -EIO;
        inode_t *inode;
        inode_t *lower_inode;
        page_t *lower_page;
        char *kaddr, *lower_kaddr;

        print_entry_location();

        inode = page->mapping->host;
        lower_inode = INODE_TO_LOWER(inode);


        if (lower_inode->i_mapping->a_ops->sync_page)
#if LINUX_VERSION_CODE < KERNEL_VERSION(2,6,17)
                err = lower_inode->i_mapping->a_ops->sync_page(page);
	return err;
#else
                lower_inode->i_mapping->a_ops->sync_page(page);
#endif /* LINUX_VERSION_CODE < KERNEL_VERSION(2,6,17) */

}


struct address_space_operations monitorfs_aops =
{
        writepage:      monitorfs_writepage,
        readpage:       monitorfs_readpage,
        prepare_write:  monitorfs_prepare_write,
        commit_write:   monitorfs_commit_write,
        bmap:           monitorfs_bmap,
        sync_page:      monitorfs_sync_page,
};

/*
 * Local variables:
 * c-basic-offset: 4
 * End:
 */
