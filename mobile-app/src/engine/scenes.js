/* @flow */

import React from 'react'
import { Actions, Scene, ActionConst } from 'react-native-router-flux'
import { LoginScene } from '@Account/scenes'
import {
    TabScene,
    InstructionScene,
    VideoScene,
} from '@Activity/scenes'
import {
    YoutubeScene,
} from '@Video/scenes'
import {
    ChapterScene,
    ViewScene
} from '@Book/scenes'

export default Actions.create(
    <Scene key="root">
        <Scene key="home" component={TabScene} type={ActionConst.RESET} title="Trang chủ"/>
        <Scene key="login" component={LoginScene} direction='vertical' type={ActionConst.RESET} hideNavBar />
        <Scene key="instruction" component={InstructionScene} direction='vertical' />
        <Scene key="videoplayer" component={VideoScene} direction='vertical' />
        <Scene key="youtube" component={YoutubeScene} direction='vertical' />
        <Scene key="chapters" component={ChapterScene} panHandlers={null} />
        <Scene key="chapterview" component={ViewScene} panHandlers={null} />
    </Scene>
)
