/* @flow */

import React, { Component } from 'react'
import { View, ListView, Text, RecyclerViewBackedScrollView, RefreshControl } from 'react-native'
import connect from './connect'
import VideoItem from '@Video/components/VideoItem'
import SGListView from 'react-native-sglistview'
import GiftedSpinner from 'react-native-gifted-spinner'
import Style from '@theme/styles'

type Props = {
    videos: Object,
    fetchVideos: Function
}

class VideoContainer extends Component {
    props: Props

    constructor(props) {
        super(props);
        this.state = {
            refreshing: false,
        }
    }

    async componentWillMount() {
        this.props.fetchVideos(1)
        this.createDataSource(this.props)
    }

    componentWillReceiveProps(nextProps) {
        this.createDataSource(nextProps)
    }

    createDataSource({ videos }) {
        const ds = new ListView.DataSource({
            rowHasChanged: (r1, r2) => r1 !== r2
        })
        this.dataSource = ds.cloneWithRows(videos.data)
        this.nextPage = videos.nextPage
    }

    renderRow(video) {
        return (
            <VideoItem data={video} key={video.id}/>
        )
    }

    loadMore = () => {
        const { videos, fetchVideos } = this.props
        if (videos.hasMore === true) {
            return fetchVideos(videos.nextPage)
        }
    }

    _onRefresh() {
        this.setState({refreshing: true})

        this.props.fetchVideos(1).then(() => {
            this.setState({refreshing: false})
        })
    }

    render() {
        const { videos, fetchVideos } = this.props

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
                    videos.loading &&
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

export default connect(VideoContainer)
