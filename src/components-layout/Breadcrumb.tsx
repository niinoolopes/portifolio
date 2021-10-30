import useNavigate from "../hooks/useNavigate"
import { BreadcrumbItem } from '../types/global'

export default function Breadcrumb(props: any) {

  const { urlNavigate } = useNavigate()

  return !props?.items
    ? null
    : (
      <section id="breadcrumb" className="bg-white border-bottom mb-2 p-2 px-lg-3">
        <nav className="overflow-auto">
          <ol className="breadcrumb mb-0 mt-1 flex-nowrap">
            {props?.items.map((item: BreadcrumbItem) => (
              <li
                key={item.label}
                className={`breadcrumb-item small ${!!item.url ? '' : 'active'} ${item.url ? 'cursor-pointer' : ''}`}
              >
                <span
                  className={item.active ? 'cursor-pointer text-balck' : ''}
                  onClick={() => item.url && urlNavigate(String(item.url))}
                >{item.label}</span>
              </li>
            ))}
          </ol>
        </nav>
      </section>
    )
}