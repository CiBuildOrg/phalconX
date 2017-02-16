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

class ChapterItem extends Component {
    props: Props

    render() {
        const { data } = this.props

        return (
            <Card style={{marginBottom: 0, elevation: 0}}>
                <Button style={{padding: 0, margin: 0}} onPress={() => Actions.chapterview({data: data})}>
                    <CardItem style={styles.header}>
                        <View style={styles.information}>
                            <Text style={styles.title}>{data.title}</Text>
                            <Text style={styles.descriptionText}>{data.description}</Text>
                        </View>
                    </CardItem>
                </Button>
            </Card>
        )
    }
}

ChapterItem.defaultProps = {
    data: [],
}

export default ChapterItem
