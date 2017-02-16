/* @flow */

import React from 'react'
import { View, Image, Text } from 'react-native'
import Icon from 'react-native-vector-icons/FontAwesome'
import { Button } from '@components'
import styles from './styles'
import Style from '@theme/styles'

const FacebookForm = (props: Props): React$Element<any> => {
    return (
        <Image style={styles.background}
            source={require('./img/background-login.jpg')}
        >
            <View style={styles.container}>
                <View style={styles.logoContainer}>
                    <Image source={require('./img/logo-invert.png')} style={styles.logo} />
                </View>
                <View style={styles.welcomeContainer}>
                    <Text style={styles.welcomeText}>Thỏa niềm</Text>
                    <Text style={styles.welcomeText}>đam mê</Text>
                </View>
                <View style={styles.buttonContainer}>
                    <Button onPress={props.loginSkip} raised>
                        <Text style={{fontFamily: 'Helvetica', fontSize: 15, color: Style.ICON_COLOR}}>
                        Tiếp tục
                        </Text>
                    </Button>
                </View>
            </View>
        </Image>
    )
}

export default FacebookForm
