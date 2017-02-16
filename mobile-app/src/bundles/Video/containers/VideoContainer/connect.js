/* @flow */

import { compose } from 'recompose'
import { connect } from 'react-redux'
import { fetchVideos } from '@store/modules/video'

const mapStateToProps = (state) => ({
    videos: state.videos,
})

const mapActionsToProps = { fetchVideos }

export default (container) => compose(
    connect(
        mapStateToProps,
        mapActionsToProps,
    )
)(container)
