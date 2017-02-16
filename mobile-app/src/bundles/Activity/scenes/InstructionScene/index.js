/* @flow */

import React from 'react'
import InstructionContainer from '@Activity/containers/InstructionContainer'

const InstructionScene = (props: Props): React$Element<any> => {
    return (
        <InstructionContainer data={props.data}/>
    )
}

export default InstructionScene
