import { useState, useCallback, useContext } from "react";
import axios from 'axios'
import { GlobalContext } from '../GlobalContext'

export default function useFetch() {
  const { baseApi, setAlert, token } = useContext(GlobalContext)
  // const [data, setData] = useState(null);
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(false);

  const request = useCallback(async (method, url, body = {}) => {

    let data = null
    let status = null
    let message = null

    try {
      setError(null);
      setLoading(true);

      // const res = await Axios[method](url, body)

      const res = await axios({
        method: method,
        url: `${baseApi}/${url}`,
        data: body,
        headers: {
          "Content-Type": "application/json",
          "Authorization": token ? `Bearer ${token}` : ''
        }
      });

      data = res.data.data
      status = res.status
      message = res.data.message

    } catch (err) {
      console.log(err)
      
      setError(err.response.data.message);
      status = null
      data = null

      setAlert({
        type: 'error',
        label: err.response.data.message
      })

    } finally {
      // setData(data)
      setLoading(false);

      return { status, data, message }
    }

  }, [])

  return { error, loading, request };
}