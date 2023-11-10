import { darken, lighten } from "@mui/material/styles";
import { intervalToDuration } from "date-fns";

export const getBackgroundColor = (color, mode) =>
  mode === "dark" ? darken(color, 0.7) : lighten(color, 0.7);

export const getHoverBackgroundColor = (color, mode) =>
  mode === "dark" ? darken(color, 0.6) : lighten(color, 0.6);

export const getSelectedBackgroundColor = (color, mode) =>
  mode === "dark" ? darken(color, 0.5) : lighten(color, 0.5);

export const getSelectedHoverBackgroundColor = (color, mode) =>
  mode === "dark" ? darken(color, 0.4) : lighten(color, 0.4);

export const daysBefore = (days) => {
  const date = new Date();
  date.setDate(date.getDate() - days);
  return date;
};

export const getAge = (dob) => {
  let duration = intervalToDuration({
    start: dob,
    end: new Date(),
  });

  return `${duration.years} an(s), ${duration.months} mois, ${duration.days} jour(s)`;
};

export const isDateValid = (dateStr) => !isNaN(new Date(dateStr));
