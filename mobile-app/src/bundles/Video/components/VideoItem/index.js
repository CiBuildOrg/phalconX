/* @flow */

import React, { Component } from 'react'
import { Image, View, Text } from 'react-native'
import { Card, CardItem, MyIcon, Button, Label } from '@components'
import styles from './styles'
import Style from '@theme/styles'
import { Actions } from 'react-native-router-flux'

type Props = {
    data: Object
}

class VideoItem extends Component {
    props: Props

    render() {
        const { data } = this.props

        return (
            <Card style={{marginBottom: Style.MARGIN / 3}}>
                <Button style={{padding: 0, margin: 0}} onPress={() => Actions.youtube({data: data})}>
                    <CardItem style={styles.header}>
                        <View style={styles.cover}>
                            <Image style={styles.coverImage} source={{uri: data.cover}} />
                            <View style={styles.overlay}>
                                <View style={styles.videoIcon}>
                                    <Image source={require('./img/play-icon.png')} style={{width: Style.THUMBNAIL_WIDTH / 3, height: Style.THUMBNAIL_HEIGHT / 3}}/>
                                </View>
                                <View style={styles.timeLabel}>
                                    <Label style={styles.timeText}>{data.time}</Label>
                                </View>
                            </View>
                        </View>
                        <View style={styles.information}>
                            <Text style={styles.title}>{data.title}</Text>
                            <Text style={styles.authorText}>{data.author}      {data.humandatecreated}</Text>
                        </View>
                    </CardItem>
                </Button>
            </Card>
        )
    }
}

VideoItem.defaultProps = {
    data: [],
}

export default VideoItem
