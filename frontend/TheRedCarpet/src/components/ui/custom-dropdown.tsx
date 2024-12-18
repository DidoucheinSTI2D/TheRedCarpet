import React from "react";
import {
  DropdownMenu as DropdownMenuPrimitive,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "./dropdown-menu";

export function CustomDropdownMenu({
  children,
  open,
  onOpenChange,
}: {
  children: React.ReactNode;
  open?: boolean;
  onOpenChange?: (open: boolean) => void;
}) {
  React.useEffect(() => {
    if (open) {
      document.body.style.overflow = "auto";
      document.body.style.paddingRight = "0px";
    }
  }, [open]);

  return (
    <DropdownMenuPrimitive open={open} onOpenChange={onOpenChange}>
      {children}
    </DropdownMenuPrimitive>
  );
}

export { DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger };
