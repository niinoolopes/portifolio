import React, { useCallback } from 'react'

export default function useForm({ t, v, min, val } = {}) {
  const [value, setValue] = React.useState(() => val || '');
  const [error, setError] = React.useState(false);

  const validation = useCallback((value) => {
    if (!v) return true;

    if (value.length < min) {
      setError(`Digite no minimo ${min} caracteres!`)
      return false

    } else if (value.length === 0) {
      setError('Preencha um valor!')
      return false

    } else {
      setError(false)
      return true
    }
  }, [min, v])

  const onChange = useCallback(({ target }) => {
    let _value = null

    if (t == 'checkbox') {
      _value = target.checked
    } else {
      _value = target.value
    }

    if (error) validation(_value)

    setValue(_value)

  }, [validation, error])

  return {
    value, setValue,
    error,
    validate: () => validation(value),
    onChange,
    onBlur: () => validation(value),
  }
}
