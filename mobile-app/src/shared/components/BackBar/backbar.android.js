/* @flow */

import React from 'react'
import { View, StyleSheet, Text } from 'react-native'
import Style from '@theme/styles'
import Icon from 'react-native-vector-icons/Ionicons'
import { Actions } from 'react-native-router-flux'
import { MyIcon, Button } from '@components'

type Props = {
  children?: string,
}

const styles = StyleSheet.create({
    container: {
        flexDirection: 'row',
        height: 50,
        backgroundColor: Style.PRIMARY_COLOR,
        justifyContent: 'flex-start',
        elevation: 3
    },
    backButton: {
        alignItems: 'center',
        justifyContent: 'center',
        marginLeft: Style.MARGIN
    },
    title: {
        fontWeight: 'bold',
        fontSize: Style.FONT_SIZE,
        marginLeft: -50,
        color: Style.ICON_COLOR
    }
})

const BackBar = (props: Props): React$Element<any> => {
    const style = props.style || {}
    const title = props.title || ''
    const icon = props.icon || ''

    return (
        <View style={styles.container}>
            <Button style={styles.backButton} onPress={() => Actions.pop()}>
                <Icon name={icon} color='#fff' size={Style.ICON_SIZE_MEDIUM} />
            </Button>
            <View style={{justifyContent: 'center', alignItems: 'center', flexDirection: 'row', flex: 1}}>
                <Text style={styles.title}>{props.title}</Text>
            </View>
        </View>
    )
}

export default BackBar
