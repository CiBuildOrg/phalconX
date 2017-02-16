/* @flow */

import { createStore, applyMiddleware, compose, combineReducers } from 'redux'
import reduxThunkMiddleware from 'redux-thunk'
import createLogger from 'redux-logger'
import promiseMiddleware from '@store/middlewares/promiseMiddleware'
import * as reducers from './reducers'

const logger = createLogger() // DEV
const enhancer = compose(
    applyMiddleware(
        reduxThunkMiddleware,
        promiseMiddleware,
        logger // DEV
    )
)

// const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || enhancer; // DEV

export default function configureStore(initialState) {
    const store = createStore(
        combineReducers({ ...reducers }),
        initialState,
        // composeEnhancers(
            enhancer
        // )
    )

    return store
}
