import ContentTitle from "./ContentTitle"

type ContentSectionProps = {
  isFetching?: boolean
  title?: string
  btns?: any
  children: any
}

export default function ContentSection({ isFetching, title, btns, children }: ContentSectionProps) {

  let css = ''

  if (title) css = 'justify-content-start'
  if (btns) css = 'justify-content-end'
  if (title && btns) css = 'justify-content-between'

  return isFetching ? null : (
    <section className="bg-white shadow-sm mb-2 p-2 p-lg-3 border-bottom">

      {(title || btns) && (
        <div className={`${css} d-flex align-items-center text-body border-bottom mb-2`}>
          {title &&
            <ContentTitle text={title} />
          }
          {btns &&
            <div className="d-flex m-0">
              {btns}
            </div>
          }
        </div>
      )}

      {children}

    </section>
  )
}
