import React from "react";
import { CircularProgress } from "@mui/material";

const Loading = () => {
  return (
    <div
      style={{
        height: "100vh",
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        width: "100vw",
      }}
    >
      <CircularProgress color="primary" />
    </div>
  );
};

export default Loading;
