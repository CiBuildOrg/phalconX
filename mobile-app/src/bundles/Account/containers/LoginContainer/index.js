/* @flow */

import React, { Component } from 'react'
import FacebookForm from '@Account/components/FacebookForm'
import { Actions } from 'react-native-router-flux'
import connect from './connect'
import { AsyncStorage, View } from 'react-native'
import GiftedSpinner from 'react-native-gifted-spinner'
import Style from '@theme/styles'

type Props = {
    user: Object,
    fetchUser: Function,
}

class LoginContainer extends Component {
    props: Props

    async _skip() {
        const onesignalId = await AsyncStorage.getItem('@bida365:onesignalId', (err, res) => {
            return res
        })

        await this.props.fetchUser(onesignalId, '123456')
        return Actions.home()
    }

    render() {
        const { user } = this.props

        return (
            <View style={{flex: 1}}>
                <FacebookForm loginSkip={this._skip.bind(this)}/>
                {user.loading &&
                    <GiftedSpinner
                        style={{
                            position: 'absolute',
                            bottom: Style.MARGIN,
                            marginLeft: Style.DEVICE_WIDTH / 2 - 10
                        }}
                    />
                }
            </View>
        )
    }
}

export default connect(LoginContainer)
