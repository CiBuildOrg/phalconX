/* @flow */

import React, { Component } from 'react'
import PhotoZoom from '@Activity/components/PhotoZoom'

class InstructionContainer extends Component {
    props: Props

    render() {
        return (
            <PhotoZoom data={this.props.data}/>
        )
    }
}

export default InstructionContainer
