/* @flow */

import { StyleSheet } from 'react-native'
import Style from '@theme/styles'

const styles = StyleSheet.create({
    header: {
        flexDirection: 'row'
    },
    title: {
        color: Style.PRIMARY_TEXT_COLOR,
        fontSize: Style.FONT_SIZE
    },
    information: {
        flex: 1,
        flexDirection: 'column',
        justifyContent: 'space-around',
        padding: Style.PADDING / 2,
        paddingRight: Style.PADDING,
        paddingBottom: 0
    },
    descriptionText: {
        color: Style.SECOND_TEXT_COLOR,
        fontSize: Style.FONT_SIZE_SMALL
    }
})

export default styles
