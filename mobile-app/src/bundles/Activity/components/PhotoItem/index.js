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

class PhotoItem extends Component {
    props: Props

    render() {
        const { data } = this.props

        return (
            <Card>
                <CardItem style={styles.header}>
                    <View style={styles.avatar}>
                        <Image style={styles.avatarImage} source={{uri: data.user.data.avatar}} />
                    </View>
                    <View style={styles.information}>
                        <Text style={styles.usernameText}>{data.user.data.fullname}</Text>
                        <Text style={styles.idText}>
                            <Text style={{color: '#1976D2'}}>{data.id.toString()}</Text> - {data.humandatemodified}
                        </Text>
                    </View>
                </CardItem>

                <CardItem>
                    <Image style={styles.image} source={{uri: data.image.data.path}} />
                    <View style={styles.overlay}>
                        <View style={styles.videoIcon}>
                            <Button onPress={() => Actions.videoplayer({data: data})}>
                                <Image source={require('./img/play-icon.png')} style={{width: Style.DEVICE_WIDTH / 5, height: Style.DEVICE_WIDTH / 5}}/>
                            </Button>
                        </View>
                        <View style={styles.zoomButton}>
                            <Button onPress={() => Actions.instruction({data: data})}>
                                <MyIcon name='expand' size={Style.ICON_SIZE} color='#fff' />
                            </Button>
                        </View>
                        {data.mark.data.watched &&
                            <View style={styles.watchedLabel}>
                                <Label style={styles.watchedText}>Đã xem</Label>
                            </View>
                        }
                        <View style={styles.titleLabel}>
                            <Label style={styles.titleText}>
                                {data.title}
                            </Label>
                        </View>
                    </View>
                </CardItem>
            </Card>
        )
    }
}

PhotoItem.defaultProps = {
    data: [],
}

export default PhotoItem
