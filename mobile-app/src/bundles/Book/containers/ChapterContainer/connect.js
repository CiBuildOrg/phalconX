/* @flow */

import { compose } from 'recompose'
import { connect } from 'react-redux'
import { fetchChapters } from '@store/modules/chapter'

const mapStateToProps = (state) => ({
    chapters: state.chapters,
})

const mapActionsToProps = { fetchChapters }

export default (container) => compose(
    connect(
        mapStateToProps,
        mapActionsToProps,
    )
)(container)
