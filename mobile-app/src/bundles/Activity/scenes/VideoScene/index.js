/* @flow */

import React from 'react'
import VideoContainer from '@Activity/containers/VideoContainer'

const VideoScene = (props: Props): React$Element<any> => {
    return (
        <VideoContainer data={props.data}/>
    )
}

export default VideoScene
