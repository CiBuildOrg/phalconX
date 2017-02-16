/* @flow */

import React, { Component } from 'react'
import { View, ListView, Text, RecyclerViewBackedScrollView, RefreshControl } from 'react-native'
import connect from './connect'
import BookItem from '@Book/components/BookItem'
import SGListView from 'react-native-sglistview'
import GiftedSpinner from 'react-native-gifted-spinner'
import Style from '@theme/styles'

type Props = {
    books: Object,
    fetchBooks: Function
}

class BookContainer extends Component {
    props: Props

    constructor(props) {
        super(props);
        this.state = {
            refreshing: false,
        }
    }

    async componentWillMount() {
        this.props.fetchBooks(1)
        this.createDataSource(this.props)
    }

    componentWillReceiveProps(nextProps) {
        this.createDataSource(nextProps)
    }

    createDataSource({ books }) {
        const ds = new ListView.DataSource({
            rowHasChanged: (r1, r2) => r1 !== r2
        })
        this.dataSource = ds.cloneWithRows(books.data)
        this.nextPage = books.nextPage
    }

    renderRow(book) {
        return (
            <BookItem data={book} key={book.id}/>
        )
    }

    loadMore = () => {
        const { books, fetchBooks } = this.props
        if (books.hasMore === true) {
            return fetchBooks(books.nextPage)
        }
    }

    _onRefresh() {
        this.setState({refreshing: true})

        this.props.fetchBooks(1).then(() => {
            this.setState({refreshing: false})
        })
    }

    render() {
        const { books, fetchBooks } = this.props

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
                    books.loading &&
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

export default connect(BookContainer)
