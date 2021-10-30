import React, { memo } from 'react'

const Textarea = ({ label, name, value, onChange, onBlur, error, disabled }) => {
  return (

    <div className="form-group">
      {
        label &&
        <label className="mb-0 small" htmlFor={name}>{label}</label>
      }
      <textarea
        rows="2"
        className="form-control form-control-sm"
        id={name}
        value={value}
        onChange={onChange}
        onBlur={onBlur}
        disabled={disabled}
      />
      {
        error &&
        <span className="text-danger">{error}</span>
      }
    </div>
  )
}

export default memo(Textarea)