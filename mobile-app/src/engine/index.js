/* @flow */

import React, { Component } from 'react'
import { StyleSheet, Navigator, AsyncStorage, View, TextInput, NetInfo, Alert, BackAndroid } from 'react-native'
import { Router, Actions } from 'react-native-router-flux'
import { Provider } from 'react-redux'
import StatusBarAndroid from 'react-native-android-statusbar'
import OneSignal from 'react-native-onesignal'
import createStore from '@store/create'
import scenes from './scenes'
import Style from '@theme/styles'
import Icon from 'react-native-vector-icons/Ionicons'
import { AdMobBanner } from 'react-native-admob'

const store = createStore()

const styles = StyleSheet.create({
    navBar: {
        backgroundColor: Style.PRIMARY_COLOR,
        height: 50,
        borderBottomColor: Style.PRIMARY_COLOR
    },
    routerScene: {
        paddingTop: Navigator.NavigationBar.Styles.General.NavBarHeight - 10, // some navbar padding to avoid content overlap
    }
})

const titleArea = () => {
    return (
        <View style={{flexDirection: 'row', flex: 1}}>
        <AdMobBanner
            bannerSize="smartBannerPortrait"
            adUnitID="ca-app-pub-6329429639818080/9718188251" />
        </View>
    )
}

class Engine extends Component {
    async componentWillMount() {
        // check fbtoken login
        const jwt = await AsyncStorage.getItem('@bida365:jwt', (err, res) => {
            return res
        })
        console.log(jwt)

        if (jwt !== null) {
            return Actions.home()
        } else {
            return Actions.login()
        }
    }

    componentDidMount() {
        // check OneSignal playerid
        const onesignalId = AsyncStorage.getItem('@bida365:onesignalId', (err, res) => {
            return res
        })

        if (onesignalId !== null) {
            // Getting idsAvailable
            OneSignal.configure({
                onIdsAvailable: async function(device) {
                    try {
                        await AsyncStorage.setItem('@bida365:onesignalId', device.userId)
                    } catch (error) {
                        alert(error)
                    }
                }
            })
        }

        // check internet connection
        NetInfo.isConnected.fetch().then(isConnected => {
            if (!isConnected) {
                Alert.alert(
                    'Thông báo',
                    'Không có kết nối mạng',
                    [
                        {text: 'OK', onPress: () => BackAndroid.exitApp()},
                    ],
                    { cancelable: false }
                )
            }
        });
    }

    render() {
        StatusBarAndroid.setHexColor(Style.DARK_PRIMARY_COLOR)

        return (
            <Provider store={store}>
                <Router
                    navigationBarStyle={styles.navBar}
                    sceneStyle={styles.routerScene}
                    scenes={scenes}
                    renderTitle={() => titleArea()}
                    renderBackButton={() => {return null}}
                />
            </Provider>
        )
    }
}

export default Engine
