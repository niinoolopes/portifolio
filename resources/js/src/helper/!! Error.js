import React, { memo } from 'react'

const Error = ({ error }) => {
  if (!error) return null
  return (
    <div className="rounded bg-danger text-white px-3 pt-2 pb-1 mb-3" style={{ lineHeight: 2 }}>{error}</div>
  )
}

export default memo(Error)