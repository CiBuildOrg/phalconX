/* @flow */

import React, { Component } from 'react'
import VideoPlayer from '@Activity/components/VideoPlayer'

class VideoContainer extends Component {
    props: Props

    render() {
        return (
            <VideoPlayer data={this.props.data}/>
        )
    }
}

export default VideoContainer
