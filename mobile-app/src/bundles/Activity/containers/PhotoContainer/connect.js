/* @flow */

import { compose } from 'recompose'
import { connect } from 'react-redux'
import { fetchPhotos } from '@store/modules/photo'

const mapStateToProps = (state) => ({
    photos: state.photos,
})

const mapActionsToProps = { fetchPhotos }

export default (container) => compose(
    connect(
        mapStateToProps,
        mapActionsToProps,
    )
)(container)
