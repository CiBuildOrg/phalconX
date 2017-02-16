/* @flow */

import React, { Component } from 'react'
import {View, WebView } from 'react-native'
import Style from '@theme/styles'

type Props = {
    data: Object
}

class YoutubeContainer extends Component {
    props: Props

    render() {
        const { data } = this.props

        return (
            <View style={{flex: 1}}>
                <WebView
                    source={{uri: `https://www.youtube.com/embed/${data.youtubeid}?version=3&enablejsapi=1&rel=0&autoplay=1&showinfo=1&controls=1&modestbranding=0`}}
                    automaticallyAdjustContentInsets={false}
                    allowsInlineMediaPlayback={true}
                    mediaPlaybackRequiresUserAction={false}
                    javaScriptEnabled={true}
                    startInLoadingState={true}
                />
            </View>
        )
    }
}

export default YoutubeContainer
