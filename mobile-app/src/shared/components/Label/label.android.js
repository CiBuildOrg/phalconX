/* @flow */

import React from 'react'
import { View, Text, StyleSheet } from 'react-native'
import Style from '@theme/styles'

type Props = {
  children?: string,
  onPress: Function,
}

const styles = StyleSheet.create({
    label: {
        fontWeight: 'bold',
        fontSize: Style.FONT_SIZE_TITLE
    }
})

const Label = (props: Props): React$Element<any> => {
    const children = props.children || ''
    const style = props.style || {}

    return (
        <Text style={[styles.label, style]}>
            {children.toUpperCase()}
        </Text>
    )
}

export default Label
