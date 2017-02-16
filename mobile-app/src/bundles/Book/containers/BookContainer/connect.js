/* @flow */

import { compose } from 'recompose'
import { connect } from 'react-redux'
import { fetchBooks } from '@store/modules/book'

const mapStateToProps = (state) => ({
    books: state.books,
})

const mapActionsToProps = { fetchBooks }

export default (container) => compose(
    connect(
        mapStateToProps,
        mapActionsToProps,
    )
)(container)
