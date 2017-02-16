import { StyleSheet } from 'react-native'
import Style from '@theme/styles'

const styles = StyleSheet.create({
    container: {
        flex: 1,
        backgroundColor: 'black',
        marginTop: -50,
        opacity: 0.7,
        width: Style.DEVICE_WIDTH
    },
    logoContainer: {
        flex: 3,
        justifyContent: 'flex-end',
        alignItems: 'center',
    },
    welcomeContainer: {
        flex: 1,
        justifyContent: 'flex-end',
        alignItems: 'center'
    },
    sloganContainer: {
        flex: 1,
        justifyContent: 'center',
        alignItems: 'center',
    },
    sloganText: {
        textAlign: 'center',
        fontFamily: 'Helvetica',
        color: Style.SECOND_TEXT_COLOR,
        fontSize: Style.FONT_SIZE_BIG,
        lineHeight: 30,
        fontWeight: '100'
    },
    welcomeText: {
        textAlign: 'center',
        fontFamily: 'Helvetica',
        color: '#d9d9d9',
        fontSize: Style.FONT_SIZE_LARGE,
        lineHeight: 35,
        fontWeight: '100'
    },
    buttonContainer: {
        flex: 2,
        justifyContent: 'center',
        alignItems: 'center'
    },
    logo: {
        width: 125,
        height: 125
    },
    background: {
        flex: 1,
        flexDirection: 'column',
        justifyContent: 'center',
        alignItems: 'center',
        width: null,
        height: null,
        resizeMode: 'cover',
        backgroundColor: 'rgba(0, 0, 0, 0)',
        marginTop: -50,
    }
})

export default styles
