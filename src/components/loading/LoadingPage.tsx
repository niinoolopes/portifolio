import { ILoading } from "../../types/global";

export default function LoadingPage({ isFetch }: ILoading) {
  return isFetch === false
    ? null
    : (
      <div id="layout-spinner" className="d-flex justify-content-center align-items-center">
        <div className="spinner-grow" role="status">
          <span className="visually-hidden">Loading...</span>
        </div>
      </div>
    )
}
