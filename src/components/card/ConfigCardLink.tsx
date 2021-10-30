import useNavigate from "../../hooks/useNavigate"
import ContentSection from "../../components-layout/ContentSection"

type ConfigCardLinkItem = {
  label: string
  url: string
  description: string
}

type ConfigCardLinkProps = {
  title?: string
  links: ConfigCardLinkItem[]
}

export default function ConfigCardLink({ links, title }: ConfigCardLinkProps) {
  const { urlNavigate } = useNavigate()

  return (
    <ContentSection
      title={title}
    >
      <div className="d-flex flex-wrap align-content-start g-2">
        {links.map(item => (
          <div className="col-12 col-md-4 col-lg-3 p-1" key={item.label}>
            <div
              className="cursor-pointer card h-100"
              onClick={() => urlNavigate(item.url)}
            >
              <div className="card-body">
                <h5 className="card-title">{item.label}</h5>
                <p className="card-text">{item.description}.</p>
              </div>
            </div>
          </div>
        ))}
      </div>
    </ ContentSection>
  )
}
