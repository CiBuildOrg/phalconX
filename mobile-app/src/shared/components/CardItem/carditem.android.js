/* @flow */

import React from 'react'
import { View, StyleSheet } from 'react-native'

type Props = {
  children?: string,
}

const styles = StyleSheet.create({
    carditem: {
        justifyContent: 'flex-start'
    }
})

const CardItem = (props: Props): React$Element<any> => {
    const children = props.children || ''
    const style = props.style || {}

    return (
        <View style={[styles.carditem, style]}>
            {children}
        </View>
    )
}

export default CardItem
