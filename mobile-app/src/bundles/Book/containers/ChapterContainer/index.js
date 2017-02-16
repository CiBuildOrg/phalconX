/* @flow */

import React, { Component } from 'react'
import { View, ListView, Text, RecyclerViewBackedScrollView, RefreshControl } from 'react-native'
import connect from './connect'
import ChapterItem from '@Book/components/ChapterItem'
import SGListView from 'react-native-sglistview'
import GiftedSpinner from 'react-native-gifted-spinner'
import { BackBar, NoContent } from '@components'
import Style from '@theme/styles'

type Props = {
    chapters: Object,
    fetchChapters: Function
}

class ChapterContainer extends Component {
    props: Props

    constructor(props) {
        super(props);
        this.state = {
            refreshing: false,
        }
    }

    async componentWillMount() {
        this.props.fetchChapters(this.props.data.id, 1)
        this.createDataSource(this.props)
    }

    componentWillReceiveProps(nextProps) {
        this.createDataSource(nextProps)
    }

    createDataSource({ chapters }) {
        const ds = new ListView.DataSource({
            rowHasChanged: (r1, r2) => r1 !== r2
        })
        this.dataSource = ds.cloneWithRows(chapters.data)
        this.nextPage = chapters.nextPage
    }

    renderRow(chapter) {
        return (
            <ChapterItem data={chapter} key={chapter.id}/>
        )
    }

    loadMore = () => {
        const { chapters, fetchChapters } = this.props
        if (chapters.hasMore === true) {
            return fetchChapters(this.props.data.id, chapters.nextPage)
        }
    }

    _onRefresh() {
        this.setState({refreshing: true})

        this.props.fetchChapters(this.props.data.id, 1).then(() => {
            this.setState({refreshing: false})
        })
    }

    render() {
        const { chapters, fetchChapters, data } = this.props

        return (
            <View style={{flex: 1}}>
                <BackBar icon='ios-arrow-back' title={data.name}/>
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

                {chapters.data.length === 0 &&
                    <NoContent message='Sách đang cập nhật' />
                }

                {
                    chapters.loading &&
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

export default connect(ChapterContainer)
