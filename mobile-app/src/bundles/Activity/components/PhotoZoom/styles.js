/* @flow */

import { StyleSheet } from 'react-native'
import Style from '@theme/styles'

const styles = StyleSheet.create({
    container: {
        justifyContent: 'center',
        backgroundColor: Style.BACKGROUND_COLOR,
        flex: 1
    },
    image: {
        padding: 0,
        margin: 0
    },
    title: {
        flexDirection: 'row',
        height: 50,
        justifyContent: 'center',
        margin: Style.MARGIN,
        padding: Style.PADDING
    },
    description: {
        flexDirection: 'row',
        justifyContent: 'center',
        margin: Style.MARGIN,
        padding: Style.PADDING
    },
    textStyle: {
        color: '#fff',
        fontSize: Style.FONT_SIZE,
        textAlign: 'center'
    }
})

export default styles
