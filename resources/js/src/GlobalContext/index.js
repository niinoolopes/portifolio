import React, { createContext, useCallback, useContext, useEffect, useState } from 'react'

export const GlobalContext = createContext()

export const GlobalStorage = ({ children }) => {

  const [baseApi, setBaseApi] = useState('')
  const [baseUrl, setBaseUrl] = useState('')
  const [alert, setAlert] = useState('')
  const [login, setLogin] = useState(false)
  const [token, setToken] = useState('')
  const [user, setUser] = useState({})
  const [statusColeta, setStatusColeta] = useState(false)

  useEffect(() => {
    clearTimeout(fn)
    let fn = setTimeout(() => {
      setAlert(false)
    }, 3000)
  }, [alert])

  const handleLogin = useCallback(({ user, token }) => {
    setUser(user)
    setToken(token)
    setLogin(true)
  })

  const handleLogout = useCallback(() => {
    setUser({})
    setToken('')
    setLogin(false)
  })

  const storage = {
    handleLogin, handleLogout,
    baseApi, setBaseApi,
    baseUrl, setBaseUrl,
    alert, setAlert,
    login, setLogin,
    token, setToken,
    user, setUser,
    statusColeta, setStatusColeta
  }

  return (
    <GlobalContext.Provider value={storage}>
      {children}
    </GlobalContext.Provider>
  )
}


export default function ContextGlobal() {
  return useContext(GlobalContext)
}