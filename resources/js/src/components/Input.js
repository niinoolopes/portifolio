import React, { memo } from 'react'

const Input = ({ label, type, name, value, onChange, onBlur, error, placeholder, disabled, required }) => {
  return (

    <div className="form-group mb-2">
      {
        label &&
        <label className="mb-0 small" htmlFor={name}>{label}</label>
      }
      <input
        className="form-control form-control-sm"
        id={name}
        name={name}
        type={type}
        value={value}
        onChange={onChange}
        onBlur={onBlur}
        placeholder={placeholder}
        disabled={disabled}
        required={required ? true : false}
      />
      {
        error &&
        <span className="text-danger">{error}</span>
      }
    </div>
  )
}

export default memo(Input)