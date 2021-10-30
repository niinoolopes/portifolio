import React from 'react'
import { useContextGlobal } from "../context/global";
import useNavigate from "../hooks/useNavigate";
import { routerLinks } from "../routes/links";
import { IRouterListItem } from "../types/global";

export default function HeaderMenu() {
  const { login } = useContextGlobal()
  const { urlNavigate } = useNavigate()

  return !login
    ? null
    : (
      <ul className="m-0 p-0 px-md-1 d-md-none">
        {routerLinks.map(({ Icon, url, label }: IRouterListItem) => (
          <li
            key={`${label}-${url}`}
            onClick={() => urlNavigate(url)}
            className="btn btn-sm text-secondary shadow-none d-inline-flex justify-content-center"
          >
            {Icon && <Icon size="21" />}
          </li>
        ))}
      </ul>
    )
}
