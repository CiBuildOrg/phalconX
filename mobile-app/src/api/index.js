/* @flow */

import { mapInFrames } from 'next-frame'
import { AsyncStorage } from 'react-native'
import { HOST } from '../conf'

export default {
    // get all photo from server
    fetchPhotos: async (pageNumber) => {
        const jwt = await AsyncStorage.getItem('@bida365:jwt')

        const response = await fetch(HOST + '/v1/photo?page=' + pageNumber + '&include=image,mark,user', {
            method: 'GET',
            headers: {
                'Accept-Language': 'en-us,en;q=0.5',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + JSON.parse(jwt).AuthToken
            },
        })

        const responseJson = await response.json()

        await mapInFrames(responseJson)

        return responseJson
    },

    // login skip
    fetchUser: async (fbEmail, fbToken) => {
        const response = await fetch(HOST + '/v1/user/login/anonymous', {
            method: 'POST',
            headers: {
                'Accept-Language': 'en-us,en;q=0.5',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                email: fbEmail,
                password: fbToken,
            }),
        })

        const responseJson = await response.json()
        await mapInFrames(responseJson)

        return responseJson
    },

    // get videos
    fetchVideos: async (pageNumber) => {
        const jwt = await AsyncStorage.getItem('@bida365:jwt')

        const response = await fetch(HOST + '/v1/clip?page=' + pageNumber, {
            method: 'GET',
            headers: {
                'Accept-Language': 'en-us,en;q=0.5',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + JSON.parse(jwt).AuthToken
            },
        })

        const responseJson = await response.json()

        await mapInFrames(responseJson)

        return responseJson
    },

    // get books
    fetchBooks: async (pageNumber) => {
        const jwt = await AsyncStorage.getItem('@bida365:jwt')

        const response = await fetch(HOST + '/v1/book?page=' + pageNumber, {
            method: 'GET',
            headers: {
                'Accept-Language': 'en-us,en;q=0.5',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + JSON.parse(jwt).AuthToken
            },
        })

        const responseJson = await response.json()

        await mapInFrames(responseJson)

        return responseJson
    },

    // get all chapters
    fetchChapters: async (bookid, pageNumber) => {
        const jwt = await AsyncStorage.getItem('@bida365:jwt')

        const response = await fetch(`${HOST}/v1/book/chapters?page=${pageNumber}&id=${bookid}`, {
            method: 'GET',
            headers: {
                'Accept-Language': 'en-us,en;q=0.5',
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + JSON.parse(jwt).AuthToken
            },
        })

        const responseJson = await response.json()

        await mapInFrames(responseJson)

        return responseJson
    },
}
