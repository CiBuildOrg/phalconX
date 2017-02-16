/* @flow */

import { StyleSheet } from 'react-native'
import Style from '@theme/styles'

const styles = StyleSheet.create({
    header: {
        padding: Style.PADDING,
        flexDirection: 'row'
    },
    footer: {
        padding: Style.PADDING,
        flexDirection: 'row'
    },
    title: {
        color: Style.PRIMARY_TEXT_COLOR,
        fontSize: Style.FONT_SIZE
    },
    image: {
        width: Style.DEVICE_WIDTH - (Style.MARGIN * 2),
        height: Style.DEVICE_WIDTH * 2 / 3.5,
        resizeMode: 'cover',
        alignSelf: 'center'
    },
    loveCount: {
        paddingTop: Style.PADDING,
        paddingRight: Style.PADDING,
        marginLeft: - Style.PADDING + 3
    },
    overlay: {
        width: Style.DEVICE_WIDTH - (Style.MARGIN * 2),
        position: 'absolute',
        left: 0,
        top: 0,
        backgroundColor: 'black',
        height: Style.DEVICE_WIDTH * 2 / 3.5,
        opacity: 0.8,
        elevation: 5
    },
    control: {
        flexDirection: 'row',
        justifyContent: 'flex-end',
        flex: 1
    },
    videoIcon: {
        position: 'relative',
        alignItems: 'center',
        flexDirection: 'column',
        justifyContent: 'center',
        flex: 1
    },
    zoomButton: {
        position: 'absolute',
        bottom: 0,
        right: 0,
    },
    watchedLabel: {
        position: 'absolute',
        right: Style.MARGIN,
        padding: Style.PADDING / 2,
        margin: Style.MARGIN,
        borderWidth: 0.5,
        borderColor: Style.DIVIDER_TEXT_COLOR
    },
    watchedText: {
        color: Style.DIVIDER_TEXT_COLOR,
        fontSize: Style.FONT_SIZE_SMALLER
    },
    titleLabel: {
        position: 'absolute',
        left: 0,
        padding: Style.PADDING / 2,
        margin: Style.MARGIN / 2
    },
    titleText: {
        color: Style.ICON_COLOR,
        fontSize: Style.FONT_SIZE_SMALL
    },
    actionContent: {
        position: 'absolute',
        top: Style.MARGIN,
        right: Style.MARGIN * 3,
        backgroundColor: '#fff',
        borderRadius: 2,
        elevation: 3
    },
    buttonFooter: {
        padding: 0,
        marginRight: Style.MARGIN
    },
    avatar: {
        justifyContent: 'center'
    },
    avatarImage: {
        width: Style.AVATAR_WIDTH,
        height: Style.AVATAR_HEIGHT,
        borderRadius: Style.AVATAR_WIDTH / 2,
        borderWidth: 1,
        borderColor: Style.LIGHT_PRIMARY_COLOR
    },
    information: {
        flex: 1,
        flexDirection: 'column',
        justifyContent: 'space-around',
        paddingLeft: Style.PADDING / 2
    },
    usernameText: {
        color: Style.PRIMARY_TEXT_COLOR,
        fontSize: Style.FONT_SIZE
    },
    idText: {
        color: Style.SECOND_TEXT_COLOR,
        fontSize: Style.FONT_SIZE_SMALL
    },
    buttonRecord: {
        width: 30,
        alignItems: 'flex-end',
        marginRight: 0
    }
})

export default styles
