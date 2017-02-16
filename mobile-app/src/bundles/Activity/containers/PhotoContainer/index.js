/* @flow */

import React, { Component } from 'react'
import { View, ListView, Text, RecyclerViewBackedScrollView, RefreshControl } from 'react-native'
import connect from './connect'
import PhotoItem from '@Activity/components/PhotoItem'
import SGListView from 'react-native-sglistview'
import GiftedSpinner from 'react-native-gifted-spinner'
import Style from '@theme/styles'

type Props = {
    photos: Object,
    fetchPhotos: Function
}

class PhotoContainer extends Component {
    props: Props

    constructor(props) {
        super(props);
        this.state = {
            refreshing: false,
        }
    }

    componentWillMount() {
        this.props.fetchPhotos(1)
        this.createDataSource(this.props)
    }

    componentWillReceiveProps(nextProps) {
        this.createDataSource(nextProps)
    }

    createDataSource({ photos }) {
        const ds = new ListView.DataSource({
            rowHasChanged: (r1, r2) => r1 !== r2
        })
        this.dataSource = ds.cloneWithRows(photos.data)
        this.nextPage = photos.nextPage
    }

    renderRow(photo) {
        return (
            <PhotoItem data={photo} key={photo.id}/>
        )
    }

    loadMore = () => {
        const { photos, fetchPhotos } = this.props
        if (photos.hasMore === true) {
            return fetchPhotos(photos.nextPage)
        }
    }

    _onRefresh() {
        this.setState({refreshing: true})

        this.props.fetchPhotos(1).then(() => {
            this.setState({refreshing: false})
        })
    }

    render() {
        const { photos, fetchPhotos } = this.props

        return (
            <View style={{flex: 1}}>
                <SGListView
                    enableEmptySections
                    dataSource={this.dataSource}
                    renderRow={this.renderRow}
                    ref={'listview'}
                    initialListSize={1000}
                    stickyHeaderIndices={[]}
                    onEndReachedThreshold={1000}
                    onEndReached={this.loadMore}
                    scrollRenderAheadDistance={1000}
                    pageSize={10}
                    showsVerticalScrollIndicator={true}
                    automaticallyAdjustContentInsets={false}
                    renderScrollComponent={props => <RecyclerViewBackedScrollView {...props} />}
                    refreshControl={
                        <RefreshControl
                            refreshing={this.state.refreshing}
                            onRefresh={this._onRefresh.bind(this)}
                        />
                    }
                />

                {
                    photos.loading &&
                    <GiftedSpinner
                        style={{
                            position: 'absolute',
                            bottom: Style.MARGIN,
                            marginLeft: Style.DEVICE_WIDTH / 2 - 10
                        }}
                    />
                }
            </View>
        )
    }
}

export default connect(PhotoContainer)
