/* @flow */

import api from '@api'
import { AsyncStorage } from 'react-native'

export const LOGIN = 'account/LOGIN'
export const LOGIN_SUCCESS = 'account/LOGIN_SUCCESS'
export const LOGIN_FAIL = 'account/LOGIN_FAIL'

type User = Object<{
    [key: number]: {
    name: string
    }
}>

type Action = Object<{
    types: Array<string>,
    promise: Promise
}>

const initialState = {
    data: null,
    loaded: false,
}

export default function user(state: User = initialState, action: Action): User {
    switch (action.type) {
        case LOGIN:
            return {
                ...state,
                loading: true,
            }
        case LOGIN_SUCCESS:
            let data = state.data
            data = action.response.response
            try {
                AsyncStorage.setItem('@bida365:jwt', JSON.stringify(data))
            } catch (error) {
                alert(error)
            }

            return Object.assign(
                {},
                state,
                {
                    loading: false,
                    loaded: true,
                    error: null,
                    data: data,
                }
            )
        case LOGIN_FAIL:
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

export const fetchUser = (email, token): Action => ({
    types: [LOGIN, LOGIN_SUCCESS, LOGIN_FAIL],
    promise: api.fetchUser(email, token),
})
