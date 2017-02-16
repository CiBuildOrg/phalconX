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
    overlay: {
        width: Style.THUMBNAIL_WIDTH * 2,
        height: Style.THUMBNAIL_HEIGHT,
        position: 'absolute',
        left: 0,
        top: 0,
        backgroundColor: 'black',
        opacity: 0.5
    },
    videoIcon: {
        position: 'relative',
        alignItems: 'center',
        flexDirection: 'column',
        justifyContent: 'center',
        flex: 1
    },
    cover: {
        justifyContent: 'center'
    },
    coverImage: {
        width: Style.THUMBNAIL_WIDTH * 2,
        height: Style.THUMBNAIL_HEIGHT,
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
    timeLabel: {
        position: 'absolute',
        right: Style.MARGIN / 5,
        padding: Style.PADDING / 5,
        margin: Style.MARGIN / 5,
        backgroundColor: 'black'
    },
    timeText: {
        color: Style.DIVIDER_TEXT_COLOR,
        fontSize: Style.FONT_SIZE_SMALLEST
    },
    authorText: {
        color: Style.SECOND_TEXT_COLOR,
        fontSize: Style.FONT_SIZE_SMALLEST
    }
})

export default styles
