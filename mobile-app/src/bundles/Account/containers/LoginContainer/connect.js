/* @flow */

import { compose } from 'recompose'
import { connect } from 'react-redux'
import { fetchUser } from '@store/modules/account'

const mapStateToProps = (state) => ({
    user: state.user,
})

const mapActionsToProps = { fetchUser }

export default (container) => compose(
    connect(
        mapStateToProps,
        mapActionsToProps,
    )
)(container)
