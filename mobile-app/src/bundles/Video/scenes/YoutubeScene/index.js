/* @flow */

import React from 'react'
import YoutubeContainer from '@Video/containers/YoutubeContainer'

const YoutubeScene = (props: Props): React$Element<any> => {
    return (
        <YoutubeContainer data={props.data} />
    )
}

export default YoutubeScene
