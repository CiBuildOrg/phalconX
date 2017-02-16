/* @flow */

import React, { Component } from 'react'
import { View, Text } from 'react-native'
import { Actions } from 'react-native-router-flux'
import PhotoView from 'react-native-photo-view'
import { CardItem } from '@components'
import * as Animatable from 'react-native-animatable'
import styles from './styles'
import Style from '@theme/styles'

type Props = {
    data: String
}

const myHeight = Style.DEVICE_WIDTH * 2 / 3 + Style.MARGIN

class PhotoZoom extends Component {
    props: Props

    constructor(props) {
        super(props)
        this.state = {
            height: myHeight,
            showText: true,
        }
    }

    _onScale() {
        this.setState({
            height: myHeight * 2,
            showText: false
        })
    }

    async _onTap() {
        await this.setState({
            height: myHeight,
            showText: true
        })

        this.refs.title.fadeInDown(500)
        this.refs.description.fadeInUp(500)
    }

    render() {
        const { data } = this.props
        const { height, showText } = this.state

        return (
            <View style={styles.container}>
                {showText &&
                    <Animatable.View style={styles.title} ref='title'>
                        <Text style={styles.textStyle}>
                            {data.title}
                        </Text>
                    </Animatable.View>
                }

                <PhotoView
                    source={{uri: data.image.data.path}}
                    minimumZoomScale={1}
                    maximumZoomScale={2}
                    androidScaleType='fitCenter'
                    style={[styles.image, {height: height}]}
                    onScale={() => this._onScale()}
                    onTap={() => this._onTap()}
                />

                {showText &&
                    <Animatable.View style={styles.description} ref='description'>
                        <Text style={styles.textStyle}>
                            {data.description}
                        </Text>
                    </Animatable.View>
                }
            </View>
        )
    }
}

export default PhotoZoom
