/* @flow */

import { StyleSheet } from 'react-native'
import Style from '@theme/styles'

const styles = StyleSheet.create({
    header: {
        flexDirection: 'row'
    },
    title: {
        color: Style.PRIMARY_TEXT_COLOR,
        fontSize: Style.FONT_SIZE_BIG
    },
    cover: {
        justifyContent: 'center'
    },
    coverImage: {
        width: Style.THUMBNAIL_WIDTH,
        height: Style.THUMBNAIL_HEIGHT * 1.5,
        resizeMode: 'cover',
        alignSelf: 'center'
    },
    information: {
        flex: 1,
        flexDirection: 'column',
        justifyContent: 'space-around',
        padding: Style.PADDING / 2,
        paddingRight: Style.PADDING,
    },
    authorText: {
        color: Style.PRIMARY_TEXT_COLOR,
        fontSize: Style.FONT_SIZE
    },
    overviewText: {
        color: Style.SECOND_TEXT_COLOR,
        fontSize: Style.FONT_SIZE_SMALLER
    }
})

export default styles
