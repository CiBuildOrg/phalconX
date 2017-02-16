/* @flow */

import React from 'react'
import Icon from 'react-native-vector-icons/Ionicons'

type Props = {
  children?: string,
}

const MyIcon = (props: Props): React$Element<any> => {
    const { name, size, color, outline, iconStyle } = props
    let iconName = `md-${name}`

    if (outline) {
        iconName = `${iconName}-outline`
    }

    return (
        <Icon name={iconName} size={size} color={color} iconStyle={iconStyle}/>
    )
}

export default MyIcon
