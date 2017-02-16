/* @flow */

import React from 'react'
import { View, StyleSheet } from 'react-native'
import Style from '@theme/styles'

type Props = {
  children?: string,
}

const styles = StyleSheet.create({
    card: {
        flexDirection: 'column',
        justifyContent: 'flex-start',
        margin: Style.MARGIN,
        borderRadius: 2,
        elevation: 2
    }
})

const Card = (props: Props): React$Element<any> => {
    const children = props.children || ''
    const style = props.style || {}

    return (
        <View style={[styles.card, style]}>
            {children}
        </View>
    )
}

export default Card
