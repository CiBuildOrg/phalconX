/* @flow */

import _ from 'lodash'
import api from '@api'

export const LOAD = 'chapter/list/LOAD'
export const LOAD_SUCCESS = 'chapter/list/LOAD_SUCCESS'
export const LOAD_FAIL = 'chapter/list/LOAD_FAIL'

type Chapters = Object<{
    [key: number]: {
    name: string
    }
}>

type Action = Object<{
    types: Array<string>,
    promise: Promise
}>

const initialState = {
    data: [],
    loaded: false,
    bookid: 0
}

export default function chapters(
    state: Chapters = initialState,
    action: Action
): Chapters {
    switch (action.type) {
        case LOAD:
            return {
                ...state,
                loading: true,
            }
        case LOAD_SUCCESS:
            let data = state.data
            let nextPage = state.nextPage
            let hasMore = state.hasMore

            if (state.bookid === action.bookid) {
                if (action.page === 1) {
                    data = action.response.records
                } else {
                    data = state.data.concat(action.response.records)
                }
            }

            if (state.bookid !== action.bookid) {
                data = action.response.records
            }

            nextPage = (action.response.records.length > 0) ? action.response.meta.nextPage : 0
            hasMore = (action.response.records.length > 0) ? action.response.meta.hasMore : false
            return Object.assign(
                {},
                state,
                {
                    loading: false,
                    loaded: true,
                    error: null,
                    data: data,
                    nextPage: nextPage,
                    hasMore: hasMore,
                    bookid: action.bookid
                }
            )
        case LOAD_FAIL:
            return {
                ...state,
                loading: false,
                loaded: false,
                error: action.error,
                data: [],
            }
        default:
            return state
    }
}

export const fetchChapters = (bookid = 0, page = 1): Action => ({
    types: [LOAD, LOAD_SUCCESS, LOAD_FAIL],
    bookid: bookid,
    page: 1,
    promise: api.fetchChapters(bookid, page)
})
