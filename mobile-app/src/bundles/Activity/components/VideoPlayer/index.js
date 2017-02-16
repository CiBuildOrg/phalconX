/* @flow */

import React, { Component } from 'react'
import { View, Text } from 'react-native'
import VPlayer from '@components/VPlayer/VideoPlayer'
import { Actions } from 'react-native-router-flux'
import styles from './styles'

type Props = {
    data: String
}

class VideoPlayer extends Component {
    props: Props

    constructor(props) {
        super(props)
    }

    render() {
        const { data } = this.props

        return (
            <View style={styles.container}>
                <VPlayer
                    ref='player'
                    source={{ uri: data.image.data.mp4Path, mainVer: 1, patchVer: 0 }}
                    resizeMode={ 'contain' }
                    paused={false}
                    repeat={false}
                    muted={true}
                    title={data.title}
                    volume={0}
                    rate={1}
                    controlTimeout={15000}
                    videoStyle={styles.player}
                    style={styles.playerContainer}
                    onBack={() => Actions.pop()}
                />
            </View>
        )
    }
}

export default VideoPlayer
