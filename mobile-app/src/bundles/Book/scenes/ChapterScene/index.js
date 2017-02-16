/* @flow */

import React from 'react'
import ChapterContainer from '@Book/containers/ChapterContainer'

const ChapterScene = (props: Props): React$Element<any> => {
    return (
        <ChapterContainer data={props.data} />
    )
}

export default ChapterScene
