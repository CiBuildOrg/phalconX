/* @flow */

import api from '@api'

export const LOAD = 'activity/photo/LOAD'
export const LOAD_SUCCESS = 'activity/photo/LOAD_SUCCESS'
export const LOAD_FAIL = 'activity/photo/LOAD_FAIL'

type Photos = Object<{
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
    loaded: false
}

export default function photos(
    state: Photos = initialState,
    action: Action
): Photos {
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
            if (action.page === 1) {
                data = action.response.records
            } else {
                data = state.data.concat(action.response.records)
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
                    hasMore: hasMore
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

export const fetchPhotos = (page = 1): Action => ({
    types: [LOAD, LOAD_SUCCESS, LOAD_FAIL],
    page: page,
    promise: api.fetchPhotos(page)
})
