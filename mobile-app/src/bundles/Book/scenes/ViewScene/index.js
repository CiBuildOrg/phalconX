/* @flow */

import React from 'react'
import { View, WebView } from 'react-native'
import { BackBar } from '@components'
import Style from '@theme/styles'

const ViewScene = (props: Props): React$Element<any> => {
    return (
        <View style={{flex: 1}}>
            <BackBar icon='ios-arrow-back' title={props.data.title}/>
            <WebView
                source={{uri: props.data.slug}}
                javaScriptEnabledAndroid={true}
                scalesPageToFit={true}
                domStorageEnabledAndroid={true}
                startInLoadingState={true}
            />
        </View>
    )
}

export default ViewScene
