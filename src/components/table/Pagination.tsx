import { useCallback, useEffect, useState } from "react"
import { pagination } from "../../contextData/globals"
import { IformSearchExtrato } from "../../types/financa"
import { IPaginationLink, IPaginationLinks, IPaginationProps } from "../../types/global"
import Select from "../form/Select"

const prepareLink = (total: number, perPage: number, current: number): IPaginationLink[] => {
  let links: IPaginationLink[] = []

  let pageTotal = Math.ceil(total / perPage)

  for (let numPage = 1; numPage <= pageTotal; numPage++) {
    links.push({
      label: String(numPage),
      page: numPage,
      active: +numPage === +current
    })
  }

  const offset = current < 5 ? 0 : current - 5

  return links.splice(offset, 9)
}

export default function Pagination(props: IPaginationProps) {

  const [links, setLinks] = useState<IPaginationLinks>(() => {
    return {
      ...pagination,
      links: prepareLink(+props.total, +props.per_page, +props.page)
    }
  })

  const handleClick = useCallback(async (key: string, value: any) => {
    props.set((obj: IformSearchExtrato) => {
      const newObj = {
        ...obj,
        [key]: value,

      }

      if (key === 'per_page') {
        newObj.page = 1
      }

      return newObj
    })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [])

  useEffect(() => {
    setLinks((obj) => {
      return {
        ...obj,
        links: prepareLink(+props.total, +props.per_page, +props.page)
      }
    })
    /* eslint-disable-next-line react-hooks/exhaustive-deps */
  }, [props])


  return (
    <section className="row g-2 mx-0 mt-auto">
      <div className="col-12 col-sm-3 col-lg-2 col-xl-1 my-1">
        <Select
          name="fnit_enable"
          defaultValue={String(props.per_page)}
          onChange={({ target }: any) => handleClick('per_page', Number(target.value))}
          disabled={props.total < 15}
        >
          <option value="15">15</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="75">75</option>
          <option value="100">100</option>
        </Select>
      </div>

      <nav className="col-12 col-sm-9 col-lg-10 col-xl-1 my-1">
        <div className="container-pagination">
          <ul className="pagination m-0">

            {props.page > 8 && (
              <li className="page-item">
                <span
                  className="cursor-pointer page-link py-1"
                  onClick={() => handleClick('page', Number(1))}
                >
                  <span aria-hidden="true">&laquo;&laquo;</span>
                </span>
              </li>
            )}

            {props.page > 8 && (
              <li className="page-item">
                <span
                  className="cursor-pointer page-link py-1"
                  onClick={() => handleClick('page', Number(+props.page - 1))}
                >
                  <span aria-hidden="true">&laquo;</span>
                </span>
              </li>
            )}

            {links.links.map((item: IPaginationLink) => (
              <li key={`link-paginate-${item.page}`}
                className={`page-item ${item.active ? 'active' : ''}`}
                onClick={() => handleClick('page', Number(item.page))}
              >
                <span className="cursor-pointer page-link py-1">
                  {item.label}
                </span>
              </li>
            ))}

            {props.page < props.last_page && (
              <li className="page-item">
                <span
                  className="cursor-pointer page-link py-1"
                  onClick={() => handleClick('page', Number(+props.page + 1))}
                >
                  <span aria-hidden="true">&raquo;</span>
                </span>
              </li>
            )}

            {(+props.page + 10) < props.last_page && (
              <li className="page-item">
                <span
                  className="cursor-pointer page-link py-1"
                  onClick={() => handleClick('page', Number(props.last_page))}
                >
                  <span aria-hidden="true">&raquo;&raquo;</span>
                </span>
              </li>
            )}


          </ul>
        </div>
      </nav>
    </section>
  )
}
