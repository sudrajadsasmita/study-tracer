FROM nginx


ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN sudo addgroup --system ${GID} group

# RUN sudo adduser --system --gid ${GID} group
