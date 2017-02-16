/* @flow */

import React, { Component } from 'react'
import { View, StyleSheet } from 'react-native'
import { TabViewAnimated, TabBarTop } from 'react-native-tab-view'
import Icon from 'react-native-vector-icons/Ionicons'
import Style from '@theme/styles'
import {
    PhotoScene
} from '@Activity/scenes'
import {
    BookScene
} from '@Book/scenes'
import {
    VideoScene
} from '@Video/scenes'

const styles = StyleSheet.create({
    container: {
        flex: 1,
    },
    page: {
        flex: 1,
        alignItems: 'center',
        justifyContent: 'center',
    },
});

_photo: Object
_book: Object
_video: Object

class TabScene extends Component {
    constructor(props) {
        super(props)
        this.state = {
            index: 0,
            routes: [
                { key: '1', icon: 'md-browsers' },
                { key: '2', icon: 'md-book' },
                { key: '3', icon: 'logo-youtube' }
            ]
        }
    }

    _handleChangeTab = (index) => {
        this.setState({ index });
    }

    _renderIcon = ({ route }: any) => {
        return (
            <Icon name={route.icon} size={26} color={'#fff'} />
        )
    }

    _renderHeader = (props) => {
        return <TabBarTop {...props} style={{backgroundColor: Style.PRIMARY_COLOR}} renderIcon={this._renderIcon}/>;
    }

    _renderScene = ({ route }) => {
        switch (route.key) {
            case '1':
                return <PhotoScene ref={el => (this._photo = el)} />;
            case '2':
                return <BookScene ref={el => (this._book = el)} />;
            case '3':
                return <VideoScene ref={el => (this._video = el)} />;
            default:
                return null;
        }
    };

    render() {
        return (
            <TabViewAnimated
                style={styles.container}
                navigationState={this.state}
                renderScene={this._renderScene}
                renderHeader={this._renderHeader}
                onRequestChangeTab={this._handleChangeTab}
                lazy={true}
            />
        )
    }
}

export default TabScene
