/* @flow */

import React from 'react'
import { View, Text } from 'react-native'
import { Button, Label } from '@components'

const ActivityScene = (props) => {
  return (
    <View style={{flex: 1}}>
        <Button raised style={{backgroundColor: 'red'}}>
            <Label style={{fontSize: 9}}>thong bao</Label>
        </Button>
    </View>
  )
}

export default ActivityScene
