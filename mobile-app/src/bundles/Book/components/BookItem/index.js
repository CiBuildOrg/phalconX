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

class BookItem extends Component {
    props: Props

    render() {
        const { data } = this.props

        return (
            <Card style={{marginBottom: Style.MARGIN / 3}}>
                <Button style={{padding: 0, margin: 0}} onPress={() => Actions.chapters({data: data})}>
                    <CardItem style={styles.header}>
                        <View style={styles.cover}>
                            <Image style={styles.coverImage} source={{uri: data.cover}} />
                        </View>
                        <View style={styles.information}>
                            <Text style={styles.title}>{data.name}</Text>
                            <Text style={styles.descriptionText}>{data.overview}</Text>
                            <Text style={styles.authorText}>{data.author}</Text>
                        </View>
                    </CardItem>
                </Button>
            </Card>
        )
    }
}

BookItem.defaultProps = {
    data: [],
}

export default BookItem
