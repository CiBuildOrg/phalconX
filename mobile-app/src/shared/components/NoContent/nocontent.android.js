/* @flow */

import React from 'react'
import { View, StyleSheet, Text } from 'react-native'
import Style from '@theme/styles'
import { Label } from '@components'

type Props = {
  children?: string,
}

const styles = StyleSheet.create({
    container: {
        position: 'absolute',
        width: Style.DEVICE_WIDTH,
        height: 50,
        top: Style.DEVICE_HEIGHT / 2,
        alignItems: 'center'
    }
})

const NoContent = (props: Props): React$Element<any> => {
    const style = props.style || {}
    const message = props.message || ''

    return (
        <View style={styles.container}>
            <Label>{props.message}</Label>
        </View>
    )
}

export default NoContent
