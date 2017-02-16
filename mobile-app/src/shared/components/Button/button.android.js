/* @flow */

import React from 'react'
import { View, TouchableNativeFeedback, StyleSheet } from 'react-native'
import Style from '@theme/styles'

type Props = {
  children?: string,
  onPress: Function,
}

const styles = StyleSheet.create({
    button: {
        padding: Style.PADDING,
        alignItems: 'center'
    },
    buttonRaised: {
        borderRadius: 2,
        backgroundColor: Style.DARK_PRIMARY_COLOR,
        elevation: 3
    }
})

const Button = (props: Props): React$Element<any> => {
    const { raised, onPress } = props
    const children = props.children || ''
    const style = props.style || {}
    const disabled = props.disabled ? props.disabled : false

    if (raised) {
        return (
            <TouchableNativeFeedback
                onPress={onPress}
                background={TouchableNativeFeedback.Ripple('#FFF')}
                disabled={disabled}
            >
                <View style={[styles.button, styles.buttonRaised, style]}>
                    {children}
                </View>
            </TouchableNativeFeedback>
        )
    }

    return (
        <TouchableNativeFeedback
            onPress={onPress}
            background={TouchableNativeFeedback.Ripple()}
            disabled={disabled}
        >
            <View style={[styles.button, style]}>
                {children}
            </View>
        </TouchableNativeFeedback>
    )
}

export default Button
